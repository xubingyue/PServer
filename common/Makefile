LIBRARY=lib/libcommon.a
TARGET= $(LIBRARY)
HOME=../
CINC=-I/usr/local/tlibc/include/ -Iinclude -I$(HOME)tcommon/include

CFILE=$(wildcard source/*.c)
DFILE=$(wildcard source/*.d)

include $(HOME)/build.mk

dep:
	@mkdir -p lib

install:
	mkdir -p $(PREFIX)
	cp -rf lib $(PREFIX)
