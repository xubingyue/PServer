NAME=centerd
EXECUTABLE=1
PREFIX?=/usr/local/$(NAME)
DEPTARET_DIR=..
DEPTARGET=common

SHARED_DIR=../../PShared
DEPLOCALINCLUDE=/usr/local/TLibC/include /usr/local/include $(SHARED_DIR)/centerp/include
DEPLOCALLD=/usr/local/TLibC/lib /usr/local/lib/ $(SHARED_DIR)/centerp/lib
DEPLOCALLIBS=tlibc thrift centerp

CINC=-I include 

CINC+=$(patsubst %, -I %, $(DEPLOCALINCLUDE))
LDPATH=$(patsubst %, -L %, $(DEPLOCALLD))
DEPLIBS=$(patsubst %, -l %, $(DEPLOCALLIBS))

CINC+=$(patsubst %, -I $(DEPTARET_DIR)/%/include, $(DEPTARGET))
LDPATH+=$(patsubst %, -L $(DEPTARET_DIR)/%/lib, $(DEPTARGET))
DEPLIBS+=$(patsubst %, -l %, $(DEPTARGET))

SOURCE=source
INCLUDE=include
BINARY=bin
LIBRARY=lib
ETC=etc

TDATA=tdata
THRIFT=thrift
CC = gcc
CXX= g++
AR = ar
RM = /bin/rm -f
INSTALL=cp -rpf

ifdef MAKE_RELEASE
CFLAGS = -Wall -Wconversion -Wcast-qual -Wpointer-arith -Wredundant-decls -Wmissing-declarations -Werror --pipe -O3 $(CINC) -DMAKE_RELEASE
CXXFLAGS = -Wall -Wconversion -Wcast-qual -Wpointer-arith -Wredundant-decls -Wmissing-declarations -Werror --pipe -O3 $(CINC) -DMAKE_RELEASE
else
CFLAGS = -Wall -Wconversion -Wcast-qual -Wpointer-arith -Wredundant-decls -Wmissing-declarations -Werror --pipe -g -ggdb $(CINC) -DMAKE_DEBUG
CXXFLAGS = -Wall -Wconversion -Wcast-qual -Wpointer-arith -Wredundant-decls -Wmissing-declarations -Werror --pipe -g -ggdb $(CINC) -DMAKE_DEBUG
endif



REALCC=$(CC) $(CFLAGS)
REALLD=$(CC) $(LDPATH)
REALCXX=$(CXX) $(CXXFLAGS)
REALCXXLD=$(CXX) $(LDPATH)
REALAR=$(AR)
REALINSTALL=$(INSTALL)
REALTDATA=$(TDATA) $(CINC)
REALTHRIFT=$(THRIFT) --gen cpp:cob_style -out $(INCLUDE)

THRIFT_FILES=$(wildcard $(INCLUDE)/*.thrift)
THRIFT_SERVICES_FILES=$(wildcard $(INCLUDE)/*_services.thrift)

THRIFT_CONSTANTS_CCFILE=$(THRIFT_FILES:.thrift=_constants.cpp)
THRIFT_TYPES_CCFILE=$(THRIFT_FILES:.thrift=_types.cpp)
THRIFT_SERVICES_CCFILE=$(THRIFT_SERVICES_FILES:.thrift=.cpp)

THRIFT_CONSTANTS_HFILE=$(THRIFT_FILES:.thrift=_constants.h)
THRIFT_TYPES_HFILE=$(THRIFT_FILES:.thrift=_types.h)
THRIFT_SERVICES_HFILE=$(THRIFT_SERVICES_FILES:.thrift=.h)
THRIFT_SERVICES_SKELETON_CCFILE=$(THRIFT_SERVICES_FILES:.thrift=_async_server.skeleton.cpp)
THRIFT_SERVICES_SKELETON_CCFILE+=$(THRIFT_SERVICES_FILES:.thrift=_server.skeleton.cpp)

THRIFT_OFILE=$(THRIFT_CONSTANTS_CCFILE:.cpp=.o)
THRIFT_OFILE+=$(THRIFT_TYPES_CCFILE:.cpp=.o)
THRIFT_OFILE+=$(THRIFT_SERVICES_CCFILE:.cpp=.o)


TDATA_FILE=$(wildcard $(INCLUDE)/*.td)

TYPES_HFILE=$(patsubst %.td, %_types.h, $(TDATA_FILE))
READER_HFILE=$(TDATA_FILE:.td=_reader.h)
WRITER_HFILE=$(TDATA_FILE:.td=_writer.h)
READER_CFILE=$(patsubst $(INCLUDE)/%.td, $(SOURCE)/%_reader.c, $(TDATA_FILE))
READER_OFILE=$(READER_CFILE:.c=.o)
WRITER_CFILE=$(patsubst $(INCLUDE)/%.td, $(SOURCE)/%_writer.c, $(TDATA_FILE))
WRITER_OFILE=$(WRITER_CFILE:.c=.o)

CXXFILE=$(wildcard $(SOURCE)/*.cpp $(SOURCE)/operator/*.cpp)
CFILE=$(wildcard $(SOURCE)/*.c)
OFILE=$(CFILE:.c=.o)
OFILE+=$(CXXFILE:.cpp=.o)

LIB=$(LIBRARY)/lib$(NAME).a
APP=$(BINARY)/$(NAME)
ifeq ($(EXECUTABLE),1)
TARGET=$(APP)
else
TARGET=$(LIB)
endif

.PHONY: all clean

all:$(TYPES_HFILE) $(READER_HFILE) $(WRITER_HFILE) $(TARGET)

$(LIB): $(OFILE) $(WRITER_OFILE) $(READER_OFILE) $(THRIFT_OFILE)
	@mkdir -p $(LIBRARY)
	$(REALAR) r $(LIB) $^

$(APP): $(OFILE) $(WRITER_OFILE) $(READER_OFILE) $(THRIFT_OFILE)
	@mkdir -p $(BINARY)
	$(REALCXXLD) -o $@ $^ $(DEPLIBS)

release:
	$(MAKE) all MAKE_RELEASE=1

%.o: %.cpp
	$(REALCXX) -o $@ -c $<

#%.o: %.c
#	$(REALC) -o $@ -c $<

$(TYPES_HFILE):$(TDATA_FILE)
	$(REALTDATA) -o $(INCLUDE) -gen tlibc_types $^

$(READER_HFILE):$(TDATA_FILE)
	$(REALTDATA) -o $(INCLUDE) -gen tlibc_reader_header $^

$(WRITER_HFILE):$(TDATA_FILE)
	$(REALTDATA) -o $(INCLUDE) -gen tlibc_writer_header $^

$(READER_CFILE):$(TDATA_FILE)
	$(REALTDATA) -o $(SOURCE) -gen tlibc_reader $^
	
$(WRITER_CFILE):$(TDATA_FILE)
	$(REALTDATA) -o $(SOURCE) -gen tlibc_writer $^

%_constants.cpp:%.thrift
	$(REALTHRIFT) $<

%_types.cpp:%.thrift
	$(REALTHRIFT) $<

%_services.cpp:%_services.thrift
	$(REALTHRIFT) $<

install:
	@mkdir -p $(PREFIX)
ifeq ($(EXECUTABLE),1)
	$(REALINSTALL) $(BINARY) $(PREFIX)
	$(REALINSTALL) $(ETC) $(PREFIX)
else
	$(REALINSTALL) $(INCLUDE) $(PREFIX)
	$(REALINSTALL) $(LIBRARY) $(PREFIX)
endif

tags:
	@find $(DEPINCLUDE) -name "*.h" | xargs ctags -a --c-types=+p+x 
	@find . -name "*.c" -or -name "*.h" | xargs ctags -a --c-types=+p+x
	@find . -name "*.h" -or -name "*.c" | cscope -Rbq

clean:
	@find . -name "*.o" | xargs $(RM)
	@$(RM) $(TARGET) $(TYPES_HFILE) $(READER_HFILE) $(WRITER_HFILE) $(READER_CFILE) $(READER_OFILE) $(WRITER_CFILE) $(WRITER_OFILE) tags cscope.in.out cscope.po.out cscope.out
	@$(RM) $(THRIFT_CONSTANTS_CCFILE) $(THRIFT_TYPES_CCFILE) $(THRIFT_SERVICES_CCFILE)
	@$(RM) $(THRIFT_CONSTANTS_HFILE) $(THRIFT_TYPES_HFILE) $(THRIFT_SERVICES_HFILE)
	@$(RM) $(THRIFT_SERVICES_CCFILE)
	@$(RM) $(THRIFT_SERVICES_HFILE)
	@$(RM) $(THRIFT_SERVICES_SKELETON_CCFILE)

